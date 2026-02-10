import { useEffect, useState, useRef } from 'react';
import { motion } from 'framer-motion';
import Button from '../components/common/Button';
import Card from '../components/common/Card';
import { cvAPI } from '../services/api.ts';
import Loading from '../components/common/Loading';
import toast from 'react-hot-toast';
import CVGenerator from '../components/ai/CVGenerator';

interface CVType {
  isi_cv?: string;
  [key: string]: any;
}

const CV = () => {
  const [cv, setCV] = useState<CVType | null>(null);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [pdfUrl, setPdfUrl] = useState<string | null>(null);
  const [isLoadingPreview, setIsLoadingPreview] = useState(false);
  const pdfUrlRef = useRef<string | null>(null);

  // Fetch CV data from backend
  const fetchCV = async () => {
    setLoading(true);
    try {
      const res = await cvAPI.getCV();
      setCV(res.data.data);
      // Fetch PDF preview jika CV tersedia
      if (res.data.data) {
        fetchPdfPreview();
      } else {
        setPdfUrl(null);
      }
    } catch (err) {
      setCV(null);
      setPdfUrl(null);
    } finally {
      setLoading(false);
    }
  };

  // Fetch PDF preview dari backend
  const fetchPdfPreview = async () => {
    setIsLoadingPreview(true);
    try {
      const response = await cvAPI.exportCV();
      // Jika response berupa file blob
      const url = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
      setPdfUrl(url);
      // Cleanup url lama
      if (pdfUrlRef.current) {
        window.URL.revokeObjectURL(pdfUrlRef.current);
      }
      pdfUrlRef.current = url;
    } catch (err) {
      setPdfUrl(null);
    } finally {
      setIsLoadingPreview(false);
    }
  };

  // Cleanup url blob saat unmount
  useEffect(() => {
    return () => {
      if (pdfUrlRef.current) {
        window.URL.revokeObjectURL(pdfUrlRef.current);
      }
    };
  }, []);

  useEffect(() => {
    fetchCV();
  }, []);

  // Save CV (update)
  const handleSave = async () => {
    setSaving(true);
    try {
      await cvAPI.createUpdateCV({ isi_cv: cv?.isi_cv || '' });
      toast.success('CV saved!');
      fetchCV();
    } catch (err) {
      toast.error('Failed to save CV');
    } finally {
      setSaving(false);
    }
  };

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="container mx-auto md:px-4 py-8"
    >
      <div className="flex justify-between items-center mb-8">
        <h1 className="text-4xl font-bold">Penyusun CV</h1>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Left Column: Generator Controls */}
        <div className="lg:col-span-1">
          <CVGenerator onPreviewCV={fetchCV} />
        </div>

        {/* Right Column: Preview & Editor */}
        <div className="lg:col-span-2">
          <Card>
            {loading ? (
              <div className="py-16 flex justify-center"><Loading text="Memuat CV..." /></div>
            ) : !cv ? (
              <div className="py-16 text-center text-gray-500">CV belum tersedia. Silakan generate dengan AI atau isi data profil Anda.</div>
            ) : (
              <div className="">
                <div className="flex flex-col gap-6">
                  {/* Isi CV Editor */}
                  <div>
                    <h2 className="text-2xl font-bold mb-4">Isi CV</h2>
                    <textarea
                      className="w-full min-h-[300px] rounded-xl border-2 border-gray-200 p-4 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                      value={cv?.isi_cv || ''}
                      onChange={e => setCV(cv ? { ...cv, isi_cv: e.target.value } : { isi_cv: e.target.value })}
                      placeholder="Tulis isi CV Anda di sini..."
                    />
                    <div className="flex justify-end gap-4 mt-4">
                      <Button variant="primary" onClick={handleSave} disabled={saving}>
                        {saving ? 'Menyimpan...' : 'Simpan CV'}
                      </Button>
                    </div>
                  </div>

                  {/* Preview PDF */}
                  <div>
                    <h2 className="text-2xl font-bold mb-4">Pratinjau CV (PDF)</h2>
                    <div className="bg-white border border-gray-200 rounded-lg p-2 h-[500px] flex items-center justify-center dark:bg-gray-800 dark:border-gray-700">
                      {isLoadingPreview ? (
                        <div>Memuat pratinjau...</div>
                      ) : pdfUrl ? (
                        <iframe
                          src={pdfUrl}
                          className="w-full h-full rounded-md"
                          title="Pratinjau CV PDF"
                        />
                      ) : (
                        <div className="text-gray-500">Pratinjau belum tersedia.</div>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            )}
          </Card>
        </div>
      </div>
    </motion.div>
  );
};

export default CV;