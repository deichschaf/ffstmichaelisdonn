import React from 'react';
import { ContentGalleryProps } from '../../../../../props/props';

const ContentGallery: React.FC<React.PropsWithChildren<ContentGalleryProps>> = (
  props: ContentGalleryProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.pagegallery === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentGallery;
