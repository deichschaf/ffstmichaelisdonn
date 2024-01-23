import { useEffect, useRef } from 'react';

function useDocumentTitle(title?: string, prevailOnUnmount = false) {
  const defaultTitle = useRef(document.title);

  if (typeof process.env.REACT_APP_HOMEPAGE_TITLE !== 'undefined') {
    title = process.env.REACT_APP_HOMEPAGE_TITLE + ' - ' + title;
  }

  useEffect(() => {
    if (typeof title === 'string') {
      if (title !== null) {
        document.title = title;
      }
    }
    if (!prevailOnUnmount) {
      document.title = defaultTitle.current;
    }
  }, [title]);
}

export default useDocumentTitle;
