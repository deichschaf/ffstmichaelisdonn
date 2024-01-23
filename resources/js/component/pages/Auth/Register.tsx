import React, { useState } from 'react';
import { RegisterProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import Input from '../../atoms/Form/Input/Input';
import Label from '../../atoms/Form/Label/Label';
import AlertInfoErrorLine from '../../molecules/AlertInfoLine/Error';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import { useAuth } from '../../useHooks/useAuth';
import AuthSessionStatus from '../../utils/auth/AuthSessionStatus';

const Register: React.FC<React.PropsWithChildren<RegisterProps>> = (
  props: RegisterProps,
): JSX.Element => {
  const { register } = useAuth({
    middleware: 'guest',
    redirectIfAuthenticated: '/admin',
  });

  const [name, setName] = useState<string>('');
  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [passwordConfirmation, setPasswordConfirmation] = useState<string>('');
  const [errors, setErrors] = useState<any>([]);

  const submitForm = event => {
    event.preventDefault();

    register({
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
      setErrors,
    });
  };

  return (
    <ErrorBoundary>
      <GridSimple>
        <form onSubmit={submitForm}>
          <div className="form-group">
            <label className="form-label">Name:</label>
            <div className="controls">
              <ErrorBoundary>
                <Input
                  id="name"
                  type="text"
                  value={name}
                  className="form-control"
                  onChange={event => setName(event.target.value)}
                  required
                  autoFocus
                />
                {typeof errors.name !== 'undefined' ? (
                  <AlertInfoErrorLine text={errors.name} />
                ) : (
                  <></>
                )}
              </ErrorBoundary>
            </div>
          </div>
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
                  autoComplete="new-password"
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
            <label className="form-label"> ConfirmPassword:</label>
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
                {typeof errors.password_confirmation !== 'undefined' ? (
                  <AlertInfoErrorLine text={errors.password_confirmation} />
                ) : (
                  <></>
                )}
              </ErrorBoundary>
            </div>
          </div>
          <div className="form-group">
            <div className="controls">
              <Button type="submit" label="Register" className="btn btn-primary" />
            </div>
          </div>
        </form>
      </GridSimple>
    </ErrorBoundary>
  );
};

export default Register;
