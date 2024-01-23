import React from 'react';
import { MoreLinkProps } from '../../../props/props';
import { Link } from 'react-router-dom';

const MoreLink: React.FC<React.PropsWithChildren<MoreLinkProps>> = (
  props: MoreLinkProps
): JSX.Element => {
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <>
      [<Link to={props.url}>more...</Link>]
    </>
  );
};
export default MoreLink;
