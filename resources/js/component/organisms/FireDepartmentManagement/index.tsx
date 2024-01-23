import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentManagementProps } from '../../../props/props';
import FireDepartmentUser from '../../molecules/FireDepartmentUser';
import Spacer from '../../molecules/Spacer';

const FireDepartmentManagement: React.FC<React.PropsWithChildren<FireDepartmentManagementProps>> = (
  props: FireDepartmentManagementProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return (
    <>
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[1]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0}>
          <></>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[3]} />
        </Col>
      </Row>
      <Spacer />
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[5]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0}>
          <></>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[7]} />
        </Col>
      </Row>
      <Spacer />
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[11]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[13]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[15]} />
        </Col>
      </Row>
      <Spacer />
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[17]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[21]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0}>
          <></>
        </Col>
      </Row>
      <Spacer />
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[23]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[25]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[26]} />
        </Col>
      </Row>
      <Spacer />
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
          <FireDepartmentUser data={props.data[28]} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0}>
          <></>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0}>
          <></>
        </Col>
      </Row>
    </>
  );
};
export default FireDepartmentManagement;
