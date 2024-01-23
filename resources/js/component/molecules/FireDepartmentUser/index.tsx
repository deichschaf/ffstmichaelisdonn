import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentUserProps } from '../../../props/props';
import FireDepartmentUserPicture from '../../atoms/FireDepartmentUserPicture';
import FireDepartmentUserAdress from './adress';

const FireDepartmentUser: React.FC<React.PropsWithChildren<FireDepartmentUserProps>> = (
  props: FireDepartmentUserProps,
): JSX.Element => {
  if (typeof props.data.firstname === 'undefined') {
    return <></>;
  }
  return (
    <>
      <Row>
        <Col>
          <FireDepartmentUserPicture data={props.data} />
        </Col>
      </Row>
      <Row>
        <Col>{props.data.function}</Col>
      </Row>
      <Row>
        <Col>
          {props.data.rank} {props.data.firstname} {props.data.surname}
        </Col>
      </Row>
      {props.data.function === 'wehrfuehrer' ||
      props.data.function === 'wehrfuehrer_stellvertreter' ? (
        <FireDepartmentUserAdress
          id={props.data.id}
          city={props.data.city}
          telephonenumber={props.data.telephonenumber}
          mobilnumber={props.data.mobilnumber}
          emailadress={props.data.emailadress}
          street={props.data.street}
          housenumber={props.data.housenumber}
          zipcode={props.data.zipcode}
          telefaxnumber={props.data.telefaxnumber}
        />
      ) : (
        <></>
      )}
    </>
  );
};
export default FireDepartmentUser;
