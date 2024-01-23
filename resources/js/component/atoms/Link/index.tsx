import React from 'react';
import slugify from 'slugify';
import { LinkProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const Link: React.FC<React.PropsWithChildren<LinkProps>> = (props: LinkProps) => (
  <ErrorBoundary>
    <a
      href={props.href}
      className={props.className}
      rel={props.rel}
      target={props.target}
      onClick={props.onClick}
      data-qa={`navPoint${slugify(props.title as string)}`}
      title={props.title}
    >
      {props.title}
      {props.children}
    </a>
  </ErrorBoundary>
);

export default Link;
