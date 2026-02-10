import { motion, HTMLMotionProps } from "framer-motion";
import styled from "styled-components";
import { ReactNode, MouseEvent, forwardRef } from "react";

// Styled component for the button
const StyledButton = styled(motion.button)`
  font-weight: 600;
  border: 2px solid black;
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;

  &:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
  }

  &:hover {
    box-shadow: none !important;
  }
`;

type ButtonVariant = "primary" | "secondary" | "accent" | "outline" | "success" | "danger" | "purple" | "glass";

interface ButtonProps extends Omit<HTMLMotionProps<"button">, 'onClick' | 'onAnimationStart' | 'onDragStart' | 'onDragEnd' | 'onDrag'> {
    children: ReactNode;
    variant?: ButtonVariant;
    className?: string;
    onClick?: (e: MouseEvent<HTMLButtonElement>) => void;
    disabled?: boolean;
    type?: "button" | "submit" | "reset";
    fullWidth?: boolean;
}

const Button = forwardRef<HTMLButtonElement, ButtonProps>(({
    children,
    variant = "primary",
    className = "",
    onClick,
    disabled = false,
    type = "button",
    fullWidth = false,
    ...props
}, ref) => {
    // Define button variants
    const variants: Record<ButtonVariant, string> = {
        primary: "bg-primary text-white",
        secondary: "bg-secondary text-black",
        accent: "bg-accent text-white",
        outline: "bg-white text-black border-2 border-black",
        success: "bg-gradient-to-r from-secondary to-emerald-400 text-black",
        danger: "bg-gradient-to-r from-primary to-rose-500 text-white",
        purple: "bg-gradient-to-r from-accent to-violet-500 text-white",
        glass: "bg-white/10 backdrop-blur-md text-white border-2 border-white/20",
    };

    // Define shadow based on variant
    const getShadow = (): string => {
        if (disabled) return "shadow-none";

        switch (variant) {
            case "primary":
            case "secondary":
            case "accent":
            case "outline":
                return "shadow-[6px_6px_0px_0px_rgba(0,0,0,0.8)]";
            default:
                return "shadow-[6px_6px_0px_0px_rgba(0,0,0,0.8)]";
        }
    };

    return (
        <StyledButton
            ref={ref}
            className={`
        px-6 py-3 rounded-2xl
        ${variants[variant]}
        ${getShadow()}
        ${fullWidth ? "w-full" : ""}
        ${className}
      `}
            onClick={onClick}
            disabled={disabled}
            type={type}
            whileTap={{
                scale: disabled ? 1 : 0.97,
                y: disabled ? 0 : 4,
                boxShadow: "0px 0px 0px 0px rgba(0,0,0,0.8)",
            }}
            whileHover={{ scale: disabled ? 1 : 1.02 }}
            transition={{ type: "spring", stiffness: 500, damping: 30 }}
            {...props}
        >
            {children}
        </StyledButton>
    );
});

Button.displayName = "Button";

export default Button;
