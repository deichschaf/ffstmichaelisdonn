import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentArrayStringProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';

const ContentArrayString: React.FC<React.PropsWithChildren<ContentArrayStringProps>> = (
  props: ContentArrayStringProps,
): JSX.Element => {
  if (typeof props.content === 'undefined') {
    return <></>;
  }
  if (props.content === null) {
    return <></>;
  }
  if (typeof props.content === 'string') {
    return <ErrorBoundary>{props.content}</ErrorBoundary>;
  }
  return (
    <ErrorBoundary>
      {props.content.map((item, idx) => (
        <p key={idx}>{item}</p>
      ))}
    </ErrorBoundary>
  );
};
export default ContentArrayString;
