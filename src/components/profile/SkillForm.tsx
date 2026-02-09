import { useState, useRef } from 'react';
import { useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup';
import * as yup from 'yup';
import { motion } from 'framer-motion';
import toast from 'react-hot-toast';
import { FileUp, X } from 'lucide-react';
import Input from '../common/Input';
import Button from '../common/Button';
import { skillsAPI } from '../../services/api';
import { SKILL_LEVELS } from '../../utils/constants';

interface Skill {
  id?: number;
  nama_skill: string;
  level: string;
  sertifikasi?: string;
}

interface SkillFormProps {
  skill?: Skill | null;
  onSuccess?: () => void;
  onCancel?: () => void;
}

// Form validation schema
const schema = yup.object({
  nama_skill: yup.string().required('Skill name is required'),
  level: yup.string().required('Skill level is required')
    .oneOf(SKILL_LEVELS, 'Invalid skill level'),
  // sertifikasi is handled separately as a file
}).required();

type FormData = yup.InferType<typeof schema>;

const SkillForm: React.FC<SkillFormProps> = ({
  skill = null,
  onSuccess,
  onCancel
}) => {
  const [isLoading, setIsLoading] = useState(false);
  const [certFile, setCertFile] = useState<File | null>(null);
  const [certFileName, setCertFileName] = useState(skill?.sertifikasi || '');
  const fileInputRef = useRef<HTMLInputElement>(null);

  const isEditing = !!skill;

  // Set default values for the form
  const defaultValues: FormData = {
    nama_skill: skill?.nama_skill || '',
    level: skill?.level || '',
  };

  // Initialize form with validation
  const { register, handleSubmit, formState: { errors } } = useForm<FormData>({
    resolver: yupResolver(schema),
    defaultValues,
  });

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setCertFile(file);
      setCertFileName(file.name);
    }
  };

  const clearFile = () => {
    setCertFile(null);
    setCertFileName('');
    if (fileInputRef.current) {
      fileInputRef.current.value = '';
    }
  };

  const onSubmit = async (data: FormData) => {
    try {
      setIsLoading(true);

      // Create payload object (api.js handles FormData conversion)
      const payload: Record<string, any> = {
        nama_skill: data.nama_skill,
        level: data.level,
      };

      if (certFile) {
        payload.sertifikasi = certFile;
      }

      if (isEditing && skill?.id) {
        await skillsAPI.updateSkill(skill.id, payload);
        toast.success('Skill updated successfully');
      } else {
        await skillsAPI.createSkill(payload);
        toast.success('Skill added successfully');
      }

      if (onSuccess) onSuccess();
    } catch (error) {
      console.error('Skill form error:', error);
      // Error is handled by the API interceptor in api.js
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.3 }}
    >
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
        <Input
          label="Skill Name"
          placeholder="e.g. JavaScript, Project Management, etc."
          error={errors.nama_skill?.message}
          required
          {...register('nama_skill')}
        />

        <div className="space-y-2">
          <label className="font-medium block">
            Skill Level
            <span className="text-primary ml-1">*</span>
          </label>

          <select
            className="w-full px-4 py-3 rounded-xl border-2 border-black dark:border-gray-600 bg-white dark:bg-gray-800 text-black dark:text-white shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)] dark:shadow-none focus:ring-2 focus:ring-accent focus:outline-none focus:shadow-none"
            {...register('level')}
          >
            <option value="">Select Skill Level</option>
            {SKILL_LEVELS.map((level: string) => (
              <option key={level} value={level}>{level}</option>
            ))}
          </select>

          {errors.level && (
            <span className="text-primary text-sm">{errors.level.message}</span>
          )}
        </div>

        <div className="space-y-2">
          <label className="font-medium block">
            Certification (optional)
          </label>

          <div className="flex items-center">
            <input
              ref={fileInputRef}
              type="file"
              accept=".pdf,.jpg,.jpeg,.png"
              onChange={handleFileChange}
              className="hidden"
            />

            <div className="flex-1 flex items-center p-3 rounded-xl border-2 border-black dark:border-gray-600 bg-white dark:bg-gray-800 text-black dark:text-white shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)] dark:shadow-none">
              {certFileName ? (
                <>
                  <span className="flex-1 truncate">{certFileName}</span>
                  <button
                    type="button"
                    onClick={clearFile}
                    className="ml-2"
                  >
                    <X size={16} />
                  </button>
                </>
              ) : (
                <span className="text-gray-400">No file selected</span>
              )}
            </div>

            <Button
              type="button"
              variant="outline"
              className="ml-2 py-2"
              onClick={() => fileInputRef.current?.click()}
            >
              <FileUp size={18} className="mr-1" />
              Browse
            </Button>
          </div>

          <p className="text-xs text-gray-500">
            Accepted formats: PDF, JPG, PNG (Max 2MB)
          </p>
        </div>

        <div className="flex justify-end space-x-3">
          {onCancel && (
            <Button
              type="button"
              variant="outline"
              onClick={onCancel}
            >
              Cancel
            </Button>
          )}

          <Button
            type="submit"
            variant="primary"
            disabled={isLoading}
          >
            {isLoading ? 'Saving...' : isEditing ? 'Update Skill' : 'Add Skill'}
          </Button>
        </div>
      </form>
    </motion.div>
  );
};

export default SkillForm;