import React from 'react';
import { FooterContentProps } from '../../../../props/props';
import ErrorBoundary from '../../errorboundary';
import { Link } from 'react-router-dom';

const FooterContent: React.FC<React.PropsWithChildren<FooterContentProps>> = (
  props: FooterContentProps
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.contenturls === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <h4 className="headline">Content</h4>
      <ul className="big">
        {props.footer.contenturls.map((item, idx) => (
          <li key={idx}>
            {item.target === '_blank' ? (
              <a href={item.url} target={item.target}>
                {item.title}
              </a>
            ) : (
              <Link to={item.url}>{item.title}</Link>
            )}
          </li>
        ))}
      </ul>
    </ErrorBoundary>
  );
};
export default FooterContent;
