import React from 'react';
import classNames from 'classnames';
import slugify from 'slugify';
import ErrorBoundary from '../../../organisms/errorboundary';
import I from '../../Icon/I';

export interface IDownloadList {
  augmentedLink?: boolean;
  href?: string;
  linkText?: string;
  rel?: string;
  icon?: string;
  size?: string;
  target?: string;
  onClick?: (e: React.MouseEvent<HTMLAnchorElement, MouseEvent>) => void;
}

const DownloadLink: React.FC<React.PropsWithChildren<IDownloadList>> = (props: IDownloadList) => (
  <ErrorBoundary>
    <a
      href={props.href}
      className={classNames('link', props.augmentedLink && 'navpoint--secondary')}
      rel={props.rel}
      target={props.target}
      onClick={props.onClick}
      data-qa={`navPoint${slugify(props.linkText as string)}`}
      title={props.linkText}
    >
      <I className={props.icon} /> {props.linkText} ({props.size})
    </a>
  </ErrorBoundary>
);

export default DownloadLink;
