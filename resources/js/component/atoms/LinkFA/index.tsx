import React from 'react';
import slugify from 'slugify';
import { LinkProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import FAS from '../Icon/FAS';

const LinkFA: React.FC<React.PropsWithChildren<LinkProps>> = (props: LinkProps) => (
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
      <FAS className="location-arrow" /> {props.title}
    </a>
  </ErrorBoundary>
);

export default LinkFA;
