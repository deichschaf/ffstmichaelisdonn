import React, { CSSProperties, FC, MouseEventHandler, useEffect, useState } from 'react';
import ErrorBoundary from '../../../organisms/errorboundary';
import SVGIcon from '../../SVGIcon';

export interface BackToTopProps {
  label?: string;
  onClick?: MouseEventHandler<HTMLButtonElement>;
}

const BackToTop: FC<React.PropsWithChildren<BackToTopProps>> = (props: BackToTopProps) => {
  const [buttonStyle, setButtonStyle] = useState<CSSProperties>({});

  useEffect(() => {
    const handleScrolling = () => {
      const viewPortHeight = window.innerHeight;
      if (
        document.body.scrollTop > viewPortHeight ||
        document.documentElement.scrollTop > viewPortHeight
      ) {
        if (buttonStyle.display !== 'block') {
          const wrapper = document.querySelector('.wrapper');
          const marginRight = wrapper
            ? parseInt(window.getComputedStyle(wrapper).paddingRight, 10)
            : 0;
          const bounds = wrapper && wrapper.getBoundingClientRect();
          const right = bounds ? bounds.right - bounds.width + marginRight : 0;

          setButtonStyle({
            ...buttonStyle,
            display: 'block',
            right,
          });
        }
      } else {
        setButtonStyle({
          ...buttonStyle,
          display: 'none',
        });
      }
    };

    window.addEventListener('scroll', handleScrolling);
    return () => {
      window.removeEventListener('scroll', handleScrolling);
    };
  });

  return (
    <ErrorBoundary>
      <button
        className="backToTop"
        onClick={props.onClick}
        aria-label={props.label}
        data-qa="back-to-top"
        style={buttonStyle}
        type="button"
      >
        <SVGIcon svg="ArrowUp" alt={props.label} title={props.label} />
      </button>
    </ErrorBoundary>
  );
};

export default BackToTop;
