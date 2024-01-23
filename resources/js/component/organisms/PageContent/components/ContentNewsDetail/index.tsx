import React from 'react';
import { ContentNewsDetailProps } from '../../../../../props/props';

const ContentNewsDetail: React.FC<React.PropsWithChildren<ContentNewsDetailProps>> = (
  props: ContentNewsDetailProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.news === 'undefined') {
    return <></>;
  }
  return <>{props.data.news}</>;
};
export default ContentNewsDetail;
