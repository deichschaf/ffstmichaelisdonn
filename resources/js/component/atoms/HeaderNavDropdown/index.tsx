import React from 'react';
import { HeaderNavDropdownProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import { Link } from 'react-router-dom';

const HeaderNavDropdown: React.FC<React.PropsWithChildren<HeaderNavDropdownProps>> = (
  props: HeaderNavDropdownProps
): JSX.Element => {
  if (typeof props.link === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <li className="nav-item dropdown">
        {props.target === '_blank' ? (
          <a
            className={`nav-link ${props.subnavi.length > 0 ? 'dropdown-toggle' : ''}`}
            href={props.link}
            target={props.target}
            id={`navbardrop${props.id}`}
            data-toggle="dropdown"
          >
            {props.title}
          </a>
        ) : (
          <Link
            to={props.link}
            className={`nav-link ${props.subnavi.length > 0 ? 'dropdown-toggle' : ''}`}
            id={`navbardrop${props.id}`}
            data-toggle="dropdown"
          >
            {props.title}
          </Link>
        )}
        {props.subnavi.length > 0 ? (
          <div className="dropdown-menu">
            <ul>
              {props.subnavi.map((item, idx) => (
                <HeaderNavDropdown
                  key={idx}
                  title={item.title}
                  link={item.link}
                  subnavi={item.subnavi}
                  target={item.target}
                  rel={item.rel}
                  id={item.id}
                />
              ))}
            </ul>
          </div>
        ) : (
          <></>
        )}
      </li>
    </ErrorBoundary>
  );
};
export default HeaderNavDropdown;
