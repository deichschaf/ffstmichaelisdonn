import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { PhotoInformationProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import ContentArrayString from '../../ContentArrayString';

const PhotoInformation: React.FC<React.PropsWithChildren<PhotoInformationProps>> = (
  props: PhotoInformationProps,
): JSX.Element => {
  if (typeof props.img === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PictureSourcSet
              className="picture"
              img={props.img}
              path="/fahrzeuge/"
              images={props.images}
            />
          </Col>
        </Row>
        {props.fotograph !== '' && props.fotograph !== null ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              &copy; {props.fotograph}
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {props.title !== '' && props.title !== null ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <ContentArrayString content={props.title} />
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {props.description !== '' && props.description !== null ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <ContentArrayString content={props.description} />
            </Col>
          </Row>
        ) : (
          <></>
        )}
      </>
    </ErrorBoundary>
  );
};
export default PhotoInformation;
