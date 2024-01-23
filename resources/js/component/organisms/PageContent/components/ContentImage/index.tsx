import React from 'react';
import { ContentImageProps } from '../../../../../props/props';

const ContentImage: React.FC<React.PropsWithChildren<ContentImageProps>> = (
  props: ContentImageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentImage;
