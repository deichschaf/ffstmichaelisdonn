import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentTextLeftProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import H2 from '../../../../../atoms/Typography/H2';
import ErrorBoundary from '../../../../errorboundary';

const ContentTextLeft: React.FC<React.PropsWithChildren<ContentTextLeftProps>> = (
  props: ContentTextLeftProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      {data.title !== 'undefined' && data.title !== '' ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H2>
              <span dangerouslySetInnerHTML={{ __html: data.title }} />
            </H2>
          </Col>
        </Row>
      ) : (
        <></>
      )}
      <Row>
        <Col
          xxl={props.boxleft}
          xl={props.boxleft}
          lg={props.boxleft}
          md={props.boxleft}
          sm={props.boxleft}
          xs={12}
        >
          <div dangerouslySetInnerHTML={{ __html: props.data.text }} />
        </Col>
        <Col
          xxl={props.boxright}
          xl={props.boxright}
          lg={props.boxright}
          md={props.boxright}
          sm={props.boxright}
          xs={12}
        >
          {typeof data.image !== 'undefined' && data.image && data.image !== '' ? (
            <PictureSourcSet
              className="picture"
              img={data.image.img}
              path="/content/"
              images={data.image.images}
            />
          ) : (
            <></>
          )}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentTextLeft;
