import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { NewsBoxProps } from '../../../props/props';
import MoreLink from '../../atoms/MoreLink';
import H3 from '../../atoms/Typography/H3';
import ErrorBoundary from '../../organisms/errorboundary';
import GridSimple from '../GridSimple';

const NewsBox: React.FC<React.PropsWithChildren<NewsBoxProps>> = (
  props: NewsBoxProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridSimple>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H3 label={props.data.title} />
          </Col>
        </Row>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            {props.data.newstext}
            <MoreLink url={`/aktuelles/${props.data.id}`} />
          </Col>
        </Row>
      </GridSimple>
    </ErrorBoundary>
  );
};
export default NewsBox;
