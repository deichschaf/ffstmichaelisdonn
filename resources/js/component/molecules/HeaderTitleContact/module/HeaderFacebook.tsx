import React from 'react';
import { HeaderFacebookProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const HeaderFacebook: React.FC<React.PropsWithChildren<HeaderFacebookProps>> = (
  props: HeaderFacebookProps,
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <a href={props.url} target="_blank" rel="noreferrer">
        {props.show_icon === true ? <i className="fab fa-facebook" /> : <></>}
        {props.name !== '' ? props.name : props.url}
      </a>
    </ErrorBoundary>
  );
};
export default HeaderFacebook;
