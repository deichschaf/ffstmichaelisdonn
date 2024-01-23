import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentUserPictureProps } from '../../../props/props';
import PictureSourcSet from '../Picture/SourceSet';

const FireDepartmentUserPicture: React.FC<
  React.PropsWithChildren<FireDepartmentUserPictureProps>
> = (props: FireDepartmentUserPictureProps): JSX.Element => (
  <Row>
    <Col>
      <PictureSourcSet
        images={props.images}
        path={props.path}
        img={props.img}
        alt={props.alt}
        title={props.title}
      />
    </Col>
  </Row>
);
export default FireDepartmentUserPicture;
