import { useEffect } from 'react';
import axios from 'axios';
import useSWR from 'swr';
import { useRouter } from './useRouter';

type AuthProps = {
  middleware?: string;
  redirectIfAuthenticated?: string | number | any;
};
export const useAuth = (props: AuthProps = {}) => {
  const router = useRouter();
  const { redirectIfAuthenticated } = props;
  let config = {};
  if (sessionStorage.getItem('token') !== null) {
    const token = sessionStorage.getItem('token');
    if (token !== null) {
      const authtoken = JSON.parse(token);
      config = {
        headers: {
          'Content-type': 'application/json',
          Authorization: `${authtoken.token.token_type} ${authtoken.token.access_token}`,
        },
      };
    }
  }

  const {
    data: user,
    error,
    mutate,
  } = useSWR('/api/user', () =>
    axios
      .get('/api/user', config)
      .then(res => res.data)
      .catch(error => {
        if (typeof error.response !== 'undefined') {
          if (error.response.status === 499) {
            if (window.location.pathname !== '/login') {
              window.location.href = '/login';
            } else {
              return false;
            }
          }
          if (error.response.status !== 409) throw error;
        }
        if (window.location.pathname !== '/login') {
          console.log(window.location.pathname);
          // window.location.href = '/login';
        }
      })
  );

  const csrf = () => axios.get('/sanctum/csrf-cookie');

  const register = async ({ setErrors, ...props }) => {
    await csrf();

    setErrors([]);

    axios
      .post('/api/register', props)
      .then(() => mutate())
      .catch(error => {
        if (typeof error.response !== 'undefined') {
          if (error.response.status !== 422) throw error;
        }
        setErrors(error.response.data.errors);
      });
  };

  const login = async ({ setErrors, setStatus, ...props }) => {
    await csrf();

    setErrors([]);
    setStatus(null);

    axios
      .post('/api/login', props)
      .then(response => {
        sessionStorage.setItem('token', JSON.stringify(response.data));
      })
      .catch(error => {
        if (typeof error.response !== 'undefined') {
          if (error.response.status !== 422) throw error;
        }

        setErrors(error.response.data.errors);
      });
  };

  const forgotPassword = async ({ setErrors, setStatus, email }) => {
    await csrf();

    setErrors([]);
    setStatus(null);

    axios
      .post('/forgot-password', { email })
      .then(response => setStatus(response.data.status))
      .catch(error => {
        if (typeof error.response !== 'undefined') {
          if (error.response.status !== 422) throw error;
          setErrors(error.response.data.errors);
        }
      });
  };

  const resetPassword = async ({ setErrors, setStatus, ...props }) => {
    await csrf();

    setErrors([]);
    setStatus(null);

    axios
      .post('/reset-password', { token: router.query.token, ...props })
      // eslint-disable-next-line no-return-assign
      .then(response => (window.location.href = '/login?reset=' + btoa(response.data.status)))
      .catch(error => {
        if (typeof error.response !== 'undefined') {
          if (error.response.status !== 422) throw error;
          setErrors(error.response.data.errors);
        }
      });
  };

  const resendEmailVerification = ({ setStatus }) => {
    axios
      .post('/email/verification-notification')
      .then(response => setStatus(response.data.status));
  };

  const logout = async () => {
    if (!error) {
      await axios.post('/api/logout').then(() => {
        sessionStorage.removeItem('token');
      });
    }
    window.location.href = '/login';
  };

  useEffect(() => {
    if (props.middleware === 'guest' && redirectIfAuthenticated && user) {
      window.location.href = redirectIfAuthenticated;
    } else if (window.location.pathname === '/verify-email' && user?.email_verified_at) {
      window.location.href = redirectIfAuthenticated;
    } else if (props.middleware === 'guest' && !user) {
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    } else if (props.middleware === 'auth' && error) {
      logout();
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    }
  }, [user, error]);

  return {
    user,
    register,
    login,
    forgotPassword,
    resetPassword,
    resendEmailVerification,
    logout,
  };
};
