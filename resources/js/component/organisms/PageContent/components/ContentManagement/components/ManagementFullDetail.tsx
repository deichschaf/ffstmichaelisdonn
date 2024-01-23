import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ManagementFullDetailProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';

const ManagementFullDetail: React.FC<React.PropsWithChildren<ManagementFullDetailProps>> = (
  props: ManagementFullDetailProps,
): JSX.Element => {
  if (typeof props.surname === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          {props.function}
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <PictureSourcSet
            className="picture"
            img={props.img}
            path="/fileadmin/mitglieder/"
            images={props.images}
          />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          {props.grade} {props.firstname} {props.surname}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ManagementFullDetail;
