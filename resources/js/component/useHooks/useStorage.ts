import { Cookies } from 'react-cookie';

export interface StorageProps {
  type?: string | undefined;
  key?: string | number | undefined;
  data?: string | number | any | undefined;
}

function useStorage() {
  const getAuthCookieExpiration = (days: number = 7) => {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // 7 days
    return date;
  };
  const checkExists = (props: StorageProps) => {
    if (props.key === null || props.type === null) {
      return false;
    }
    if (typeof props.key === 'undefined' || typeof props.type === 'undefined') {
      return false;
    }

    if (typeof props.key !== 'string') {
      return false;
    }
    let content: string | null;
    content = null;
    if (props.type === 'session') {
      content = sessionStorage.getItem(props.key);
    }
    if (props.type === 'local') {
      content = localStorage.getItem(props.key);
    }
    if (props.type === 'cookie') {
      const cookie = new Cookies();
      content = cookie.get(props.key);
    }
    return content !== null;
  };
  const getItem = (props: StorageProps) => {
    if (props.key === null || props.type === null) {
      return false;
    }

    if (typeof props.key !== 'string') {
      return false;
    }
    let content: string | null;
    content = null;
    if (props.type === 'session') {
      content = sessionStorage.getItem(props.key);
    }
    if (props.type === 'local') {
      content = localStorage.getItem(props.key);
    }
    if (props.type === 'cookie') {
      const cookie = new Cookies();
      content = cookie.get(props.key);
    }
    if (content !== null) {
      return JSON.parse(content);
    }

    return null;
  };

  const setItem = (props: StorageProps) => {
    if (props.key === null || props.type === null) {
      return false;
    }
    if (typeof props.key !== 'string') {
      return false;
    }

    if (props.type === 'session') {
      sessionStorage.setItem(props.key, JSON.stringify(props.data));
      return true;
    }
    if (props.type === 'local') {
      localStorage.setItem(props.key, JSON.stringify(props.data));
      return true;
    }
    if (props.type === 'cookie') {
      const cookie = new Cookies();
      if (props.data === null) {
        cookie.remove(props.key, {
          path: '/',
          expires: getAuthCookieExpiration(1),
          sameSite: 'lax',
          httpOnly: false,
        });
      } else {
        cookie.set(props.key, JSON.stringify(props.data), {
          path: '/',
          expires: getAuthCookieExpiration(1),
          sameSite: 'lax',
          httpOnly: false,
        });
      }
      return true;
    }
    return false;
  };
  return { checkExists, getItem, setItem };
}
