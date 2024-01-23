import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { NewsBoxesProps } from '../../../props/props';
import NewsBox from '../../molecules/NewsBox';
import ErrorBoundary from '../errorboundary';

const NewsBoxes: React.FC<React.PropsWithChildren<NewsBoxesProps>> = (
  props: NewsBoxesProps,
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
          <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12} key={idx}>
            <NewsBox data={item} />
          </Col>
        ))}
      </Row>
    </ErrorBoundary>
  );
};
export default NewsBoxes;
