import { useEffect, useRef, useState } from 'react';

const useComponentVisible = (initialVisible: boolean) => {
  const [isComponentVisible, setIsComponentVisible] = useState(initialVisible);
  const ref = useRef(null);

  // eslint-disable-next-line
  const handleClickOutside = (event: any) => {
    // eslint-disable-next-line
    if (ref && ref.current && !(ref.current as any).contains(event.target)) {
      setIsComponentVisible(false);
    }
  };

  useEffect(() => {
    document.addEventListener('click', handleClickOutside, true);
    return () => document.removeEventListener('click', handleClickOutside, true);
  });

  return {
    ref,
    isComponentVisible,
    setIsComponentVisible,
  };
};

export default useComponentVisible;
