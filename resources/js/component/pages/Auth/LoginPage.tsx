import React, { useEffect, useState } from 'react';
import { LoginPageProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import Input from '../../atoms/Form/Input/Input';
import { getCookie, getCSRFToken } from '../../component_helper';
import AlertInfoErrorLine from '../../molecules/AlertInfoLine/Error';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import { useAuth } from '../../useHooks/useAuth';

const LoginPage: React.FC<React.PropsWithChildren<LoginPageProps>> = (
  props: LoginPageProps
): JSX.Element => {
  const { login } = useAuth({
    middleware: 'guest',
    redirectIfAuthenticated: '/admin',
  });

  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [shouldRemember, setShouldRemember] = useState<boolean>(false);
  const [errors, setErrors] = useState<any>([]);
  const [status, setStatus] = useState<any>(null);

  useEffect(() => {
    if (typeof props.reset !== 'undefined') {
      if (typeof props.reset.length !== 'undefined') {
        if (props.reset?.length > 0 && errors.length === 0) {
          setStatus(atob(props.reset));
        } else {
          setStatus(null);
        }
      } else {
        setStatus(null);
      }
    } else {
      setStatus(null);
    }
  });

  const submitForm = async event => {
    event.preventDefault();
    const token = getCSRFToken();
    const csrfToken = getCookie('XSRF-TOKEN');

    login({
      email,
      password,
      remember: shouldRemember,
      setErrors,
      setStatus,
      'csrf-token': token,
      _token: token,
    });
  };

  return (
    <ErrorBoundary>
      <GridSimple>
        <form onSubmit={submitForm}>
          <div className="form-group">
            <label className="form-label">Email:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  value={email}
                  name="email"
                  type="email"
                  placeholder=""
                  className="form-control"
                  onChange={event => setEmail(event.target.value)}
                  required
                  autoFocus
                />
                {typeof errors.email !== 'undefined' ? (
                  <AlertInfoErrorLine text={errors.email} />
                ) : (
                  <></>
                )}
              </ErrorBoundary>
            </div>
          </div>
          <div className="form-group">
            <label className="form-label">Password:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  id="password"
                  type="password"
                  value={password}
                  className="form-control"
                  onChange={event => setPassword(event.target.value)}
                  required
                  autoComplete="current-password"
                />
                {typeof errors.password !== 'undefined' ? (
                  <AlertInfoErrorLine text={errors.password} />
                ) : (
                  <></>
                )}
              </ErrorBoundary>
            </div>
          </div>
          <div className="form-group">
            <label className="form-label">Login merken?:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  id="remember_me"
                  type="checkbox"
                  name="remember"
                  onChange={event => setShouldRemember(event.target.checked)}
                />
              </ErrorBoundary>
            </div>
          </div>
          <div className="form-group">
            <div className="controls">
              <Button type="submit" label="Login" className="btn btn-primary" />
            </div>
          </div>
        </form>
      </GridSimple>
    </ErrorBoundary>
  );
};

export default LoginPage;
