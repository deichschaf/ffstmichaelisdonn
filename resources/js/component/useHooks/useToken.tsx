import { useState } from 'react';

export default function useToken() {
  const [token, setToken] = useState<string>('');

  const getToken = () => {
    const tokenString = sessionStorage.getItem('token') as string;
    const userToken = JSON.parse(tokenString);
    return userToken;
  };
  const saveToken = userToken => {
    sessionStorage.setItem('token', JSON.stringify(userToken));
    setToken(userToken);
  };

  return {
    setToken: saveToken,
    getToken,
  };
}
