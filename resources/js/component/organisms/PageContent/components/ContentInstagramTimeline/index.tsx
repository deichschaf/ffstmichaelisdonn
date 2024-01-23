import React from 'react';
import { ContentInstagramTimelineProps } from '../../../../../props/props';

const ContentInstagramTimeline: React.FC<React.PropsWithChildren<ContentInstagramTimelineProps>> = (
  props: ContentInstagramTimelineProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentInstagramTimeline;
