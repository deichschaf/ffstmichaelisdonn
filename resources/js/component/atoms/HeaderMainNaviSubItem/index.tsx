import React from 'react';
import { HeaderMainNaviSubItemProps } from '../../../props/props';
import { Link } from 'react-router-dom';

const HeaderMainNaviSubItem: React.FC<React.PropsWithChildren<HeaderMainNaviSubItemProps>> = (
  props: HeaderMainNaviSubItemProps
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return <Link to={props.url}>{props.title}</Link>;
};
export default HeaderMainNaviSubItem;
