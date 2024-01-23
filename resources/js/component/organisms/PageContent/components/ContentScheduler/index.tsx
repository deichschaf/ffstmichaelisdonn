import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentSchedulerProps } from '../../../../../props/props';
import PictureSourcSet from '../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../errorboundary';
import SchedulerEntry from './components/SchedulerEntry';

const ContentScheduler: React.FC<React.PropsWithChildren<ContentSchedulerProps>> = (
  props: ContentSchedulerProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.scheduler === 'undefined') {
    return <></>;
  }

  if (props.data.scheduler.length === 0) {
    return <></>;
  }

  return (
    <ErrorBoundary>
      {props.data.scheduler.map((data, idx) => (
        <SchedulerEntry key={idx} data={data} />
      ))}
    </ErrorBoundary>
  );
};
export default ContentScheduler;
