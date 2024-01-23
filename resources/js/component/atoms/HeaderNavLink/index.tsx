import React from 'react';
import { HeaderNavLinkProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import { Link } from 'react-router-dom';

const HeaderNavLink: React.FC<React.PropsWithChildren<HeaderNavLinkProps>> = (
  props: HeaderNavLinkProps
): JSX.Element => {
  if (typeof props.link === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <li className="nav-item">
        {props.target === '_blank' ? (
          <a className="nav-link" href={props.link} target={props.target}>
            {props.title}
          </a>
        ) : (
          <Link to={props.link} rel={props.rel} className="nav-link">
            {props.title}
          </Link>
        )}
      </li>
    </ErrorBoundary>
  );
};
export default HeaderNavLink;
