import { useEffect, useState } from 'react';
import './getBreakpoint.scss';

const breakpoints = {
  xs: 0,
  sm: 1,
  md: 2,
  lg: 3,
  xl: 4,
};

const getBreakpoint = () => {
  let cssVar = 'xl';
  if (document) {
    const style = getComputedStyle(document.body);
    cssVar = style.getPropertyValue('--breakpoint').trim();

    // eslint-disable-next-line react-hooks/rules-of-hooks
    const [breakpoint, setBreakpoint] = useState(cssVar);
    // eslint-disable-next-line react-hooks/rules-of-hooks
    useEffect(() => {
      const handleResize = () => {
        setBreakpoint(style.getPropertyValue('--breakpoint').trim());
      };
      window.addEventListener('resize', handleResize);
      return () => {
        window.removeEventListener('resize', handleResize);
      };
    });
    return breakpoint;
  }
  return cssVar;
};

export const isXs = () => {
  const breakpoint = getBreakpoint();
  return breakpoint === 'xs';
};

export const isSm = () => {
  const breakpoint = getBreakpoint();
  return breakpoint === 'sm';
};

export const isSmOrLower = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] <= breakpoints['sm'];
};

export const isSmOrHigher = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] >= breakpoints['sm'];
};

export const isMd = () => {
  const breakpoint = getBreakpoint();
  return breakpoint === 'md';
};

export const isMdOrLower = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] <= breakpoints['md'];
};

export const isMdOrHigher = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] >= breakpoints['md'];
};

export const isLg = () => {
  const breakpoint = getBreakpoint();
  return breakpoint === 'lg';
};

export const isLgOrLower = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] <= breakpoints['lg'];
};

export const isLgOrHigher = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] >= breakpoints['lg'];
};

export const isXl = () => {
  const breakpoint = getBreakpoint();
  return breakpoint === 'xl';
};

export const isMobile = () => {
  const breakpoint = getBreakpoint();

  return breakpoints[breakpoint] <= breakpoints['sm'];
};

export default getBreakpoint;
