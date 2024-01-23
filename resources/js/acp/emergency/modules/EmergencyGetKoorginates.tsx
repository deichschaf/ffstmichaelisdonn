import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ButtonFA from '../../../component/atoms/Buttons/ButtonFA';
import { getCookie, getCSRFToken } from '../../../component/component_helper';
import AlertOfflineBox from '../../../component/molecules/AlertBox/Online';
import AlertInfoErrorLine from '../../../component/molecules/AlertInfoLine/Error';
import GridSimple from '../../../component/molecules/GridSimple';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyGetKoorginatesProps } from '../../../props/props';

const EmergencyGetKoorginates: React.FC<React.PropsWithChildren<EmergencyGetKoorginatesProps>> = (
  props: EmergencyGetKoorginatesProps,
): JSX.Element => {
  const [getErrorText, setErrorText] = useState<string>('');
  const [getSync, setSync] = useState<boolean>(false);

  function getCoordinate() {
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    const requestOptions = {
      method: 'POST',
      headers,
      body: JSON.stringify({
        place: 'React POST Request Example',
        'csrf-token': token,
        _token: token,
      }),
    };
    fetch('/api/admin/emergency/getCoordinates/')
      .then(response => response.json())
      .then(data => {
        // @todo getCoordinate from call into Variables
        console.log(data.message);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  useEffect(() => {
    async function fetchMyApi() {
      const response = await fetch('/api/checkOffline');
      const responseData = await response.json();
      setSync(responseData.success);
    }
    fetchMyApi();
  }, []);

  if (!getSync) {
    return (
      <ErrorBoundary>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <GridSimple>
              <AlertOfflineBox />
            </GridSimple>
          </Col>
        </Row>
      </ErrorBoundary>
    );
  }
  if (props.address === '' || typeof props.address === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <GridSimple>
            <div className="form-group">
              <label className="form-label">Löse Adresse auf:</label>
              <div className="controls">
                <ErrorBoundary>
                  <ButtonFA FAclassName="earth" onClick={getCoordinate} />
                </ErrorBoundary>
              </div>
            </div>
          </GridSimple>
        </Col>
      </Row>
      {getErrorText !== '' ? <AlertInfoErrorLine text={getErrorText} /> : <></>}
    </ErrorBoundary>
  );
};
export default EmergencyGetKoorginates;
