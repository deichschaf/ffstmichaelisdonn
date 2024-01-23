import React from 'react';
import { HeaderImageProps } from '../../../props/props';

const HeaderImage: React.FC<React.PropsWithChildren<HeaderImageProps>> = (
  props: HeaderImageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default HeaderImage;
