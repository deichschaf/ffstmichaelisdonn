import React from 'react';
import { FooterNavigationProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import { Link } from 'react-router-dom';

const FooterNavigation: React.FC<React.PropsWithChildren<FooterNavigationProps>> = (
  props: FooterNavigationProps
): JSX.Element => {
  function buildFooterNavi(footerlinks) {
    if (typeof footerlinks === 'undefined') {
      return <></>;
    }
    const data = [...footerlinks];
    const list = data.map((item, idx) => (
      <li key={idx}>
        <Link to={item.url}>{item.title}</Link>
      </li>
    ));
    return list;
  }

  return (
    <nav>
      <ErrorBoundary>{buildFooterNavi(props.footerlinks)}</ErrorBoundary>
    </nav>
  );
};
export default FooterNavigation;
