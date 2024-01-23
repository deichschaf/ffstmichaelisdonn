import React from 'react';
import { HeaderEmailProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const HeaderEmail: React.FC<React.PropsWithChildren<HeaderEmailProps>> = (
  props: HeaderEmailProps,
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <a href={`mailto:${props.url}`} rel="noreferrer">
        {props.show_icon === true ? <i className="fas fa-envelope" /> : <></>}
        {props.name !== '' ? props.name : props.url}
      </a>
    </ErrorBoundary>
  );
};
export default HeaderEmail;
