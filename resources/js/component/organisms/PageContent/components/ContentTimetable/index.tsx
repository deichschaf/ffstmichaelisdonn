import React from 'react';
import { ContentTimetableProps } from '../../../../../props/props';

const ContentTimetable: React.FC<React.PropsWithChildren<ContentTimetableProps>> = (
  props: ContentTimetableProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentTimetable;
