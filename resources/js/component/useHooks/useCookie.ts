import { useState } from 'react';

export default function useCookie() {
  const [cookie, setCookie] = useState<string | null>(null);
  const getCookie = cookieName => {
    const cookieValue = localStorage.getItem(cookieName);
    if (cookieValue === null) {
      return null;
    }
    return JSON.parse(cookieValue);
  };
  const saveCookie = (cookieName = '', cookieValue = '') => {
    localStorage.setItem(cookieName, JSON.stringify(cookieValue));
    setCookie(cookieValue);
  };
  return {
    setCookie: saveCookie,
    getCookie,
  };
}
