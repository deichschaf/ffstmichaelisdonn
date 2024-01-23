import React, { useState } from 'react';
import { VerifyEmailProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import { useAuth } from '../../useHooks/useAuth';

const VerifyEmail: React.FC<React.PropsWithChildren<VerifyEmailProps>> = (
  props: VerifyEmailProps,
): JSX.Element => {
  const { logout, resendEmailVerification } = useAuth({
    middleware: 'auth',
    redirectIfAuthenticated: '/admin',
  });

  const [status, setStatus] = useState(null);
  return (
    <ErrorBoundary>
      <GridSimple>
        <div className="mb-4 text-sm text-gray-600">
          Thanks for signing up! Before getting started, could you verify your email address by
          clicking on the link we just emailed to you? If you didn&amp;t receive the email, we will
          gladly send you another.
        </div>

        {status === 'verification-link-sent' && (
          <div className="mb-4 font-medium text-sm text-green-600">
            A new verification link has been sent to the email address you provided during
            registration.
          </div>
        )}
        <div className="form-group">
          <div className="controls">
            <Button
              type="submit"
              onClick={() => resendEmailVerification({ setStatus })}
              label="Resend Verification Email"
              className="btn btn-primary"
            />
          </div>
        </div>
        <div className="form-group">
          <div className="controls">
            <Button type="submit" onClick={logout} label="Logout" className="btn btn-primary" />
          </div>
        </div>
      </GridSimple>
    </ErrorBoundary>
  );
};

export default VerifyEmail;
