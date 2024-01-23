import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentUserAdressProps } from '../../../props/props';
import FAS from '../../atoms/Icon/FAS';

const FireDepartmentUserAdress: React.FC<React.PropsWithChildren<FireDepartmentUserAdressProps>> = (
  props: FireDepartmentUserAdressProps,
): JSX.Element => {
  if (typeof props.city === 'undefined') {
    return <></>;
  }
  function getZipCity(props) {
    if (props.zipcode !== null) {
      return `${props.zipcode} ${props.city}`;
    }
    return props.city;
  }
  return (
    <>
      {props.street !== null ? (
        <Row>
          <Col>{props.street}</Col>
        </Row>
      ) : (
        <></>
      )}
      {props.city !== null ? (
        <Row>
          <Col>{getZipCity(props)}</Col>
        </Row>
      ) : (
        <></>
      )}
      {props.telephonenumber !== null ? (
        <Row>
          <Col>{props.telephonenumber}</Col>
        </Row>
      ) : (
        <></>
      )}
      {props.emailadress !== null ? (
        <Row>
          <Col>
            <FAS className="email" title="Email schreiben" />
          </Col>
        </Row>
      ) : (
        <></>
      )}
    </>
  );
};
export default FireDepartmentUserAdress;
