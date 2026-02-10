import { forwardRef, ReactNode, InputHTMLAttributes, SelectHTMLAttributes, TextareaHTMLAttributes } from "react";
import { motion } from "framer-motion";
import styled from "styled-components";

const InputWrapper = styled.div`
  position: relative;
  width: 100%;
  margin-bottom: 1.5rem;
`;

const inputStyles = `
  width: 100%;
  transition: all 0.2s ease;

  &:focus {
    outline: none;
    box-shadow: none;
  }
`;

const StyledInput = styled(motion.input)`
  ${inputStyles}
`;

const StyledSelect = styled(motion.select)`
  ${inputStyles}
`;

const StyledTextarea = styled(motion.textarea)`
  ${inputStyles}
`;

const StyledLabel = styled.label`
  font-weight: 500;
  display: block;
  margin-bottom: 0.5rem;
`;

const ErrorMessage = styled.span`
  color: #ff3366;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  display: block;
  font-weight: 500;
`;

type BaseInputProps = {
    label?: string;
    name: string;
    error?: string;
    className?: string;
    required?: boolean;
};

type InputAsInput = BaseInputProps & InputHTMLAttributes<HTMLInputElement> & {
    as?: never;
    children?: never;
};

type InputAsSelect = BaseInputProps & SelectHTMLAttributes<HTMLSelectElement> & {
    as: "select";
    children?: ReactNode;
};

type InputAsTextarea = BaseInputProps & TextareaHTMLAttributes<HTMLTextAreaElement> & {
    as: "textarea";
    children?: never;
};

type InputProps = InputAsInput | InputAsSelect | InputAsTextarea;

const Input = forwardRef<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement, InputProps>(
    (props, ref) => {
        const {
            label,
            name,
            error,
            className = "",
            required = false,
            disabled = false,
            as,
            children,
            ...restProps
        } = props;

        let Component: any = StyledInput;
        if (as === "select") Component = StyledSelect;
        if (as === "textarea") Component = StyledTextarea;

        return (
            <InputWrapper>
                {label && (
                    <StyledLabel htmlFor={name}>
                        {label}
                        {required && <span className='text-primary ml-1'>*</span>}
                    </StyledLabel>
                )}
                <Component
                    id={name}
                    name={name}
                    disabled={disabled}
                    className={`
          px-4 py-3 rounded-xl
          bg-white dark:bg-gray-800
          border-2 border-black dark:border-gray-600
          text-black dark:text-white
          shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)] dark:shadow-none
          focus:ring-2 focus:ring-accent focus:shadow-none
          disabled:opacity-70 disabled:cursor-not-allowed
          ${error ? "border-primary" : ""}
          ${className}
        `}
                    ref={ref}
                    whileFocus={{
                        y: 0,
                        x: 0,
                        boxShadow: "0px 0px 0px 0px rgba(0,0,0,0.8)",
                    }}
                    {...restProps}
                >
                    {Component !== StyledInput ? children : null}
                </Component>
                {error && <ErrorMessage>{error}</ErrorMessage>}
            </InputWrapper>
        );
    }
);

Input.displayName = "Input";

export default Input;
