import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup';
import * as yup from 'yup';
import { motion } from 'framer-motion';
import toast from 'react-hot-toast';
import Input from '../common/Input';
import Button from '../common/Button';
import { experienceAPI } from '../../services/api';

interface Experience {
  id?: number;
  institusi: string;
  posisi: string;
  lokasi: string;
  tanggal_mulai: string;
  tanggal_akhir: string | null;
  deskripsi: string;
}

interface ExperienceFormProps {
  experience?: Experience | null;
  onSuccess?: () => void;
  onCancel?: () => void;
}

// Form validation schema
const schema = yup.object({
  institusi: yup.string().required('Company name is required'),
  posisi: yup.string().required('Position is required'),
  lokasi: yup.string().required('Location is required'),
  tanggal_mulai: yup.date().required('Start date is required'),
  tanggal_akhir: yup.date().nullable(),
  deskripsi: yup.string(),
}).required();

type FormData = yup.InferType<typeof schema>;

const ExperienceForm: React.FC<ExperienceFormProps> = ({
  experience = null,
  onSuccess,
  onCancel
}) => {
  const [isLoading, setIsLoading] = useState(false);
  const isEditing = !!experience;

  // Set default values for the form
  const defaultValues: FormData = {
    institusi: experience?.institusi || '',
    posisi: experience?.posisi || '',
    lokasi: experience?.lokasi || '',
    tanggal_mulai: experience?.tanggal_mulai ? new Date(experience.tanggal_mulai) : new Date(),
    tanggal_akhir: experience?.tanggal_akhir ? new Date(experience.tanggal_akhir) : null,
    deskripsi: experience?.deskripsi || '',
  };

  // Initialize form with validation
  const { register, handleSubmit, formState: { errors } } = useForm<FormData>({
    resolver: yupResolver(schema),
    defaultValues,
  });

  const onSubmit = async (data: FormData) => {
    try {
      setIsLoading(true);

      const formattedData = {
        ...data,
        tanggal_mulai: data.tanggal_mulai.toISOString().split('T')[0],
        tanggal_akhir: data.tanggal_akhir ? data.tanggal_akhir.toISOString().split('T')[0] : null,
      };

      if (isEditing && experience?.id) {
        await experienceAPI.updateExperience(experience.id, formattedData);
        toast.success('Experience updated successfully');
      } else {
        await experienceAPI.createExperience(formattedData);
        toast.success('Experience added successfully');
      }

      if (onSuccess) onSuccess();
    } catch (error) {
      console.error('Experience form error:', error);
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
          label="Company Name"
          placeholder="e.g. Acme Corporation"
          error={errors.institusi?.message}
          required
          {...register('institusi')}
        />

        <Input
          label="Position"
          placeholder="e.g. Software Engineer"
          error={errors.posisi?.message}
          required
          {...register('posisi')}
        />

        <Input
          label="Location"
          placeholder="e.g. Jakarta, Indonesia"
          error={errors.lokasi?.message}
          required
          {...register('lokasi')}
        />

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <Input
            label="Start Date"
            type="date"
            error={errors.tanggal_mulai?.message}
            required
            {...register('tanggal_mulai')}
          />

          <Input
            label="End Date"
            type="date"
            error={errors.tanggal_akhir?.message}
            {...register('tanggal_akhir')}
          />
        </div>

        <div>
          <label className="font-medium mb-1 block">
            Description
          </label>
          <textarea
            className="w-full px-4 py-3 rounded-xl border-2 border-black dark:border-gray-600 bg-white dark:bg-gray-800 text-black dark:text-white shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)] dark:shadow-none focus:ring-2 focus:ring-accent focus:outline-none focus:shadow-none"
            rows={4}
            placeholder="Describe your responsibilities and achievements..."
            {...register('deskripsi')}
          ></textarea>
          {errors.deskripsi && (
            <span className="text-primary text-sm mt-1">{errors.deskripsi.message}</span>
          )}
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
            {isLoading ? 'Saving...' : isEditing ? 'Update Experience' : 'Add Experience'}
          </Button>
        </div>
      </form>
    </motion.div>
  );
};

export default ExperienceForm;