import React from 'react';
import { HeaderMainNaviItemProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import HeaderMainNaviSubItem from '../HeaderMainNaviSubItem';
import FAS from '../Icon/FAS';

const HeaderMainNaviItem: React.FC<React.PropsWithChildren<HeaderMainNaviItemProps>> = (
  props: HeaderMainNaviItemProps,
): JSX.Element => {
  function buildSubNavi(subnavi) {
    if (typeof subnavi === 'undefined') {
      return <></>;
    }
    const data = [...subnavi];
    const list = data.map((item, idx) => (
      <li key={idx} className={item.className}>
        <ErrorBoundary>
          <HeaderMainNaviSubItem key={idx} title={item.title} url={item.url} />
        </ErrorBoundary>
      </li>
    ));
    return <ul>{list}</ul>;
  }

  return (
    <ErrorBoundary>
      <span>
        <span className="no_l">
          {props.title}
          <FAS className="angle-down" />
        </span>
      </span>
      <div className="submenu">
        {typeof props.subnavi !== 'undefined' ? buildSubNavi(props.subnavi) : <></>}
      </div>
    </ErrorBoundary>
  );
};
export default HeaderMainNaviItem;
