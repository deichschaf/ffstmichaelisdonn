import React from 'react';
import { FooterServiceProps } from '../../../../props/props';
import ErrorBoundary from '../../errorboundary';
import { Link } from 'react-router-dom';

const FooterService: React.FC<React.PropsWithChildren<FooterServiceProps>> = (
  props: FooterServiceProps
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.serviceurls === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <h4 className="headline">Service</h4>
      <ul className="big">
        {props.footer.serviceurls.map((item, idx) => (
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
export default FooterService;
