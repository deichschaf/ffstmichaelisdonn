import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentTextProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import ContentTextImage from '../ContentTextImage';

const ContentText: React.FC<React.PropsWithChildren<ContentTextProps>> = (
  props: ContentTextProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.pagetext === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <div dangerouslySetInnerHTML={{ __html: props.data.pagetext }} />
        </Col>
      </Row>
      {typeof props.data.page_content_images !== 'undefined' ? (
        <ContentTextImage data={props.data} />
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default ContentText;
