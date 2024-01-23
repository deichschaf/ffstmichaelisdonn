import React from 'react';
import { HeaderPhoneProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const HeaderPhone: React.FC<React.PropsWithChildren<HeaderPhoneProps>> = (
  props: HeaderPhoneProps,
): JSX.Element => {
  if (typeof props.phonenumber === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <a href={`tel:${props.phonenumber_click}`} rel="noreferrer">
        {props.show_icon === true ? <i className="fas fa-phone" /> : <></>}
        {props.phonenumber}
      </a>
    </ErrorBoundary>
  );
};
export default HeaderPhone;
