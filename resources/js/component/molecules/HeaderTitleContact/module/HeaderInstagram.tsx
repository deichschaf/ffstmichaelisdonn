import React from 'react';
import { HeaderInstagramProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const HeaderInstagram: React.FC<React.PropsWithChildren<HeaderInstagramProps>> = (
  props: HeaderInstagramProps,
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <a href={props.url} target="_blank" rel="noreferrer">
        {props.show_icon === true ? <i className="fab fa-instagram" /> : <></>}
        {props.name !== '' ? props.name : props.url}
      </a>
    </ErrorBoundary>
  );
};
export default HeaderInstagram;
