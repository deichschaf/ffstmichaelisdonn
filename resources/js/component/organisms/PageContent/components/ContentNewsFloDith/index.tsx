import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentNewsFloDithProps } from '../../../../../props/props';
import NewsBoxFloDith from '../../../../molecules/NewsBoxFloDith';
import ErrorBoundary from '../../../errorboundary';

const ContentNewsFloDith: React.FC<React.PropsWithChildren<ContentNewsFloDithProps>> = (
  props: ContentNewsFloDithProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.news === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        {props.data.news.map((item, idx) => (
          <Col key={idx} xxl={3} xl={3} lg={4} md={4} sm={6} xs={12}>
            <NewsBoxFloDith data={item} />
          </Col>
        ))}
      </Row>
    </ErrorBoundary>
  );
};
export default ContentNewsFloDith;
