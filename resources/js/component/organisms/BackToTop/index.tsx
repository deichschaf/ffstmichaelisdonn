import React, { CSSProperties, FC, MouseEventHandler, useEffect, useState } from 'react';
import { BackToTopProps } from '../../../props/props';
import { ArrowUp } from '../../svgs';

const BackToTop: FC<BackToTopProps> = ({ onClick, label }) => {
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
    <button
      className="backToTop"
      onClick={onClick}
      aria-label={label}
      data-qa="back-to-top"
      style={buttonStyle}
      type="button"
    >
      <i className="fa fa-angle-up"> </i>
    </button>
  );
};
export default BackToTop;
