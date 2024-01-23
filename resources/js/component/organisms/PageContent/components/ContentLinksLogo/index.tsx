import React from 'react';
import { ContentLinksLogoProps } from '../../../../../props/props';

const ContentLinksLogo: React.FC<React.PropsWithChildren<ContentLinksLogoProps>> = (
  props: ContentLinksLogoProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentLinksLogo;
