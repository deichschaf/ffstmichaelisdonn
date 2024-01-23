import React, { useState } from 'react';
import { ForgotPasswordProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import Input from '../../atoms/Form/Input/Input';
import Label from '../../atoms/Form/Label/Label';
import AlertInfoErrorLine from '../../molecules/AlertInfoLine/Error';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import { useAuth } from '../../useHooks/useAuth';
import AuthSessionStatus from '../../utils/auth/AuthSessionStatus';

const ForgotPassword: React.FC<React.PropsWithChildren<ForgotPasswordProps>> = (
  props: ForgotPasswordProps,
): JSX.Element => {
  const { forgotPassword } = useAuth({ middleware: 'guest' });

  const [email, setEmail] = useState<string>('');
  const [errors, setErrors] = useState<any>([]);
  const [status, setStatus] = useState<any>(null);

  const submitForm = event => {
    event.preventDefault();

    forgotPassword({ email, setErrors, setStatus });
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
                  id="email"
                  type="email"
                  name="email"
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
            <div className="controls">
              <Button type="submit" label="Email Password Reset Link" className="btn btn-primary" />
            </div>
          </div>
        </form>
      </GridSimple>
    </ErrorBoundary>
  );
};

export default ForgotPassword;
