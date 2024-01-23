import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { HeaderNavTypeProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import HeaderNavDropdown from '../HeaderNavDropdown';
import HeaderNavLink from '../HeaderNavLink';

const HeaderNavType: React.FC<React.PropsWithChildren<HeaderNavTypeProps>> = (
  props: HeaderNavTypeProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.subnavi.length === 0 ? (
      <HeaderNavLink
        id={props.id}
        title={props.title}
        link={props.link}
        target={props.target}
        rel={props.rel}
        subnavi={props.subnavi}
        options={props.options}
      />
    ) : (
      <HeaderNavDropdown
        id={props.id}
        title={props.title}
        link={props.link}
        target={props.target}
        rel={props.rel}
        subnavi={props.subnavi}
        options={props.options}
      />
    )}
  </ErrorBoundary>
);
export default HeaderNavType;
