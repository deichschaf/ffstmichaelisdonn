import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentVehicleSearchProps } from '../../../../../props/props';
import Button from '../../../../atoms/Buttons/Button';
import LabelInput from '../../../../atoms/Form/LabelInput';
import { getCookie, getCSRFToken } from '../../../../component_helper';
import SaveInfoError from '../../../../molecules/SaveInfoError';
import ErrorBoundary from '../../../errorboundary';
import StationSearchList from './components/StationSearchList';
import VehicleSearchList from './components/VehicleSearchList';

const ContentVehicleSearch: React.FC<React.PropsWithChildren<ContentVehicleSearchProps>> = (
  props: ContentVehicleSearchProps
): JSX.Element => {
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getValueSearchWord, setValueSearchWord] = useState<string | number>('');
  const [getFormValid, setFormValid] = useState<boolean>(false);
  const [getVehicles, setVehicles] = useState<any>(null);
  const [getStations, setStations] = useState<any>(null);
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.vehicle_database === 'undefined') {
    return <></>;
  }

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich versendet!');
      setVehicles(data.entries.vehicles);
      setStations(data.entries.stations);
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  const searchWord = (value: string | number): void => {
    setValueSearchWord(value);
  };

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
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
    fetch('/api/get/fahrzeuge/search', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        searchword: getValueSearchWord,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  return (
    <ErrorBoundary>
      <ErrorBoundary>
        <SaveInfoError responseText={responseText} errorText={errorText} />
      </ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          Bitte geben Sie einen Suchbegriff ein:
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelInput label="Suchbegriff" value={getValueSearchWord} setParentValue={searchWord} />
          <Button onClick={SubmitForm} type="submit" label="absenden" className="btn btn-primary" />
        </Col>
      </Row>
      <ErrorBoundary>
        <VehicleSearchList data={getVehicles} />
      </ErrorBoundary>

      <ErrorBoundary>
        <StationSearchList data={getStations} />
      </ErrorBoundary>

      <ErrorBoundary>
        <SaveInfoError responseText={responseText} errorText={errorText} />
      </ErrorBoundary>
    </ErrorBoundary>
  );
};
export default ContentVehicleSearch;
