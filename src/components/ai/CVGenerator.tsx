import React, { useState, useRef } from "react";
import { motion } from "framer-motion";
import { FileText, Download, RefreshCw, Upload } from "lucide-react";
import Card from "../common/Card";
import Button from "../common/Button";
import Loading from "../common/Loading";
import { cvAPI } from "../../services/api";
import toast from "react-hot-toast";

interface AnalysisResult {
  score?: number;
  suggestions?: string[];
  [key: string]: any;
}

interface CVGeneratorProps {
  onPreviewCV?: () => void;
  className?: string;
}

const CVGenerator: React.FC<CVGeneratorProps> = ({ onPreviewCV, className = "" }) => {
  const [isGenerating, setIsGenerating] = useState(false);
  const [isUploading, setIsUploading] = useState(false);
  const [uploadedFile, setUploadedFile] = useState<File | null>(null);
  const [analysisResult, setAnalysisResult] = useState<AnalysisResult | null>(null);
  const fileInputRef = useRef<HTMLInputElement>(null);
  const [language, setLanguage] = useState("id");
  const [tone, setTone] = useState("professional");

  const handleGenerateCV = async () => {
    try {
      setIsGenerating(true);
      await cvAPI.generateCV({ language, tone });
      toast.success("CV generated successfully!");
      if (onPreviewCV) onPreviewCV();
    } catch (error: any) {
      console.error("CV generation error:", error);
      // Fallback if interceptor doesn't handle it or we want specific UI behavior
      const errorMessage = error.response?.data?.message || "Failed to generate CV. Please try again.";
      if (!error.handledByInterceptor) {
        toast.error(errorMessage);
      }
    } finally {
      setIsGenerating(false);
    }
  };

  const handleExportCV = async () => {
    try {
      const response = await cvAPI.exportCV();
      // Create a URL for the blob
      const url = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'CV.pdf');
      document.body.appendChild(link);
      link.click();
      link.remove();
      window.URL.revokeObjectURL(url);
    } catch (error) {
      console.error("CV export error:", error);
      toast.error("Failed to export CV. Please try again.");
    }
  };

  const handleFileUpload = () => {
    if (fileInputRef.current) {
      fileInputRef.current.click();
    }
  };

  const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    // Check file type
    if (
      !file.type.match("application/pdf") &&
      !file.type.match(
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
      )
    ) {
      toast.error("Please upload a PDF or DOCX file");
      return;
    }

    // Check file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
      toast.error("File size should not exceed 5MB");
      return;
    }

    setUploadedFile(file);

    try {
      setIsUploading(true);
      const response = await cvAPI.analyzeUploadedCV(file);
      setAnalysisResult(response.data.data);
      toast.success("CV analyzed successfully!");
    } catch (error) {
      console.error("CV analysis error:", error);
      // Error is handled by the API interceptor in api.js
    } finally {
      setIsUploading(false);
    }
  };

  return (
    <Card className={`${className}`}>
      <h2 className='text-2xl font-heading font-bold mb-6'>CV Generator</h2>

      <div className='space-y-6'>
        {/* AI-powered CV generation */}
        <div className='p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700'>
          <h3 className='text-lg font-bold mb-2 dark:text-white'>Generate CV with AI</h3>
          <p className='text-gray-600 dark:text-gray-300 mb-4'>
            Our AI will generate a professional CV based on your profile
            information, including education, experience, and skills.
          </p>
          <div className='flex flex-col sm:flex-row sm:flex-wrap gap-3 mb-3'>
            <div className='flex flex-col flex-1 min-w-0 sm:min-w-[120px] sm:max-w-[200px]'>
              <label className='text-xs font-medium mb-1 dark:text-gray-300'>Language</label>
              <select
                value={language}
                onChange={(e) => setLanguage(e.target.value)}
                className='rounded-xl border-2 border-gray-200 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-black dark:text-white'
              >
                <option value='id'>Bahasa Indonesia</option>
                <option value='en'>English</option>
              </select>
            </div>
            <div className='flex flex-col flex-1 min-w-0 sm:min-w-[120px] sm:max-w-[200px]'>
              <label className='text-xs font-medium mb-1 dark:text-gray-300'>Tone</label>
              <select
                value={tone}
                onChange={(e) => setTone(e.target.value)}
                className='rounded-xl border-2 border-gray-200 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-black dark:text-white'
              >
                <option value='professional'>Professional</option>
                <option value='creative'>Creative</option>
                <option value='simple'>Simple</option>
              </select>
            </div>
          </div>
          <div className='flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3'>
            <Button
              variant='primary'
              onClick={handleGenerateCV}
              disabled={isGenerating}
            >
              {isGenerating ? (
                <>
                  <RefreshCw size={18} className='mr-2 animate-spin' />
                  Generating...
                </>
              ) : (
                <>
                  <FileText size={18} className='mr-2' />
                  Generate CV
                </>
              )}
            </Button>

            <Button variant='outline' onClick={handleExportCV}>
              <Download size={18} className='mr-2' />
              Export as PDF
            </Button>
          </div>
        </div>

        {/* CV Upload and Analysis */}
        <div className='p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700'>
          <h3 className='text-lg font-bold mb-2 dark:text-white'>
            Upload & Analyze Existing CV
          </h3>
          <p className='text-gray-600 dark:text-gray-300 mb-4'>
            Upload your existing CV to analyze its content and get improvement
            suggestions.
          </p>

          <input
            ref={fileInputRef}
            type='file'
            accept='.pdf,.docx'
            onChange={handleFileChange}
            className='hidden'
          />

          <div className='flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 bg-white dark:bg-gray-700'>
            {isUploading ? (
              <Loading text='Analyzing CV...' size='16px' />
            ) : (
              <>
                <Upload size={32} className='text-gray-400 dark:text-gray-300 mb-2' />
                <p className='text-center text-gray-600 dark:text-gray-200 mb-2'>
                  {uploadedFile
                    ? uploadedFile.name
                    : "Drag & drop your CV here, or click to browse"}
                </p>
                <p className='text-xs text-gray-400 dark:text-gray-400 mb-4'>
                  Supports PDF, DOCX (max 5MB)
                </p>
                <Button
                  variant='outline'
                  onClick={handleFileUpload}
                  className='px-4 py-2'
                >
                  Browse Files
                </Button>
              </>
            )}
          </div>

          {/* Analysis Results */}
          {analysisResult && (
            <motion.div
              initial={{ opacity: 0, height: 0 }}
              animate={{ opacity: 1, height: "auto" }}
              transition={{ duration: 0.3 }}
              className='mt-6 p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600'
            >
              <h4 className='font-bold mb-2 dark:text-white'>Analysis Results</h4>

              {analysisResult.score && (
                <div className='mb-3'>
                  <p className='font-medium dark:text-gray-200'>
                    CV Score: {analysisResult.score}/100
                  </p>
                  <div className='w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mt-1'>
                    <div
                      className='bg-primary h-2.5 rounded-full'
                      style={{ width: `${analysisResult.score}%` }}
                    ></div>
                  </div>
                </div>
              )}

              {analysisResult.suggestions && (
                <div>
                  <p className='font-medium mb-2 dark:text-gray-200'>
                    Suggestions for Improvement:
                  </p>
                  <ul className='list-disc list-inside space-y-1 text-gray-600 dark:text-gray-300'>
                    {analysisResult.suggestions.map((suggestion, index) => (
                      <li key={index}>{suggestion}</li>
                    ))}
                  </ul>
                </div>
              )}
            </motion.div>
          )}
        </div>
      </div>
    </Card>
  );
};

export default CVGenerator;
