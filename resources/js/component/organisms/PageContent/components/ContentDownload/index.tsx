import React from 'react';
import { ContentDownloadProps } from '../../../../../props/props';

const ContentDownload: React.FC<React.PropsWithChildren<ContentDownloadProps>> = (
  props: ContentDownloadProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentDownload;
