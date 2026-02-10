import { ReactNode, MouseEvent, forwardRef } from "react";
import { motion, HTMLMotionProps } from "framer-motion";
import styled from "styled-components";

const StyledCard = styled(motion.div)`
  position: relative;
  border-radius: 24px;
  overflow: hidden;
`;

type ShadowSize = "sm" | "md" | "lg" | "xl";

interface CardProps extends Omit<HTMLMotionProps<"div">, 'onClick' | 'onAnimationStart' | 'onDragStart' | 'onDragEnd' | 'onDrag'> {
    children: ReactNode;
    className?: string;
    onClick?: (e: MouseEvent<HTMLDivElement>) => void;
    hoverEffect?: boolean;
    shadowSize?: ShadowSize;
}

const Card = forwardRef<HTMLDivElement, CardProps>(({
    children,
    className = "",
    onClick,
    hoverEffect = true,
    shadowSize = "md",
    ...props
}, ref) => {
    // Define shadow sizes
    const shadowSizes: Record<ShadowSize, string> = {
        sm: "shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)]",
        md: "shadow-[8px_8px_0px_0px_rgba(0,0,0,0.8)]",
        lg: "shadow-[12px_12px_0px_0px_rgba(0,0,0,0.8)]",
        xl: "shadow-[16px_16px_0px_0px_rgba(0,0,0,0.8)]",
    };

    return (
        <StyledCard
            ref={ref}
            className={`p-6 ${shadowSizes[shadowSize]} bg-white dark:bg-gray-800 border-2 border-black dark:border-gray-700 ${className}`}
            onClick={onClick}
            whileHover={
                hoverEffect
                    ? { y: -5, x: -5, boxShadow: "12px 12px 0px 0px rgba(0,0,0,0.8)" }
                    : {}
            }
            transition={{ type: "spring", stiffness: 500, damping: 30 }}
            {...props}
        >
            {children}
        </StyledCard>
    );
});

Card.displayName = "Card";

export default Card;
