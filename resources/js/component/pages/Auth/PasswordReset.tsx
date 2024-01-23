import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router';
import { useLocation } from 'react-router-dom';
import { PasswordResetProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import Input from '../../atoms/Form/Input/Input';
import AlertInfoErrorLine from '../../molecules/AlertInfoLine/Error';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import { useAuth } from '../../useHooks/useAuth';
import AuthSessionStatus from '../../utils/auth/AuthSessionStatus';

const PasswordReset: React.FC<React.PropsWithChildren<PasswordResetProps>> = (
  props: PasswordResetProps,
): JSX.Element => {
  const { token } = useParams();
  const { resetPassword } = useAuth({ middleware: 'guest' });
  const location = useLocation();
  const param_email = new URLSearchParams(location.search).get('email');
  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [passwordConfirmation, setPasswordConfirmation] = useState<string>('');
  const [errors, setErrors] = useState<any>([]);
  const [status, setStatus] = useState<any>(null);

  const submitForm = event => {
    event.preventDefault();

    resetPassword({
      email,
      password,
      password_confirmation: passwordConfirmation,
      setErrors,
      setStatus,
      token,
    });
  };

  useEffect(() => {
    setEmail(param_email || '');
  }, [param_email]);
  return (
    <ErrorBoundary>
      <GridSimple>
        <form onSubmit={submitForm}>
          <div className="form-group">
            <label className="form-label">Email:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  id="email"
                  type="email"
                  value={email}
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
            <label className="form-label">Confirm Password:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  id="passwordConfirmation"
                  type="password"
                  value={passwordConfirmation}
                  className="form-control"
                  onChange={event => setPasswordConfirmation(event.target.value)}
                  required
                />

                {typeof errors.password !== 'undefined' ? (
                  <AlertInfoErrorLine text={errors.password_confirmation} />
                ) : (
                  <></>
                )}
              </ErrorBoundary>
            </div>
          </div>
          <div className="form-group">
            <div className="controls">
              <Button type="submit" label="Reset Password" className="btn btn-primary" />
            </div>
          </div>
        </form>
      </GridSimple>
    </ErrorBoundary>
  );
};

export default PasswordReset;
