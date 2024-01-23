import React from 'react';
import { ContentCalendarProps } from '../../../../../props/props';

const ContentCalendar: React.FC<React.PropsWithChildren<ContentCalendarProps>> = (
  props: ContentCalendarProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.pagecalendar === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentCalendar;
