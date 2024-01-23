import React from 'react';
import { ContentFacebookTimelineProps } from '../../../../../props/props';

const ContentFacebookTimeline: React.FC<React.PropsWithChildren<ContentFacebookTimelineProps>> = (
  props: ContentFacebookTimelineProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentFacebookTimeline;
