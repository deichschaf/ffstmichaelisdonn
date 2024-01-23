import { ModulEmergencyScenarioProps } from '../../../../props/props';
import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../../component/organisms/errorboundary';
import Select from 'react-select';
import SaveInfoError from '../../../../component/molecules/SaveInfoError';
import GridSimple from '../../../../component/molecules/GridSimple';
import { getCookie, getCSRFToken } from '../../../../component/component_helper';

const ModulEmergencyScenario: React.FC<React.PropsWithChildren<ModulEmergencyScenarioProps>> = (
  props: ModulEmergencyScenarioProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.id === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergency_definition_id === 'undefined') {
    return <></>;
  }
  if (typeof props.emergencydata === 'undefined') {
    return <></>;
  }
  if (typeof props.emergencydata.emergencyData === 'undefined') {
    return <></>;
  }
  const [getId, setId] = useState<number>(0);
  const [getEmergencyId, setEmergencyId] = useState<number>(-1);
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const { data, emergencydata } = props;

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function setSelectedValue(id, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  function onChangeAreaId(e) {
    setEmergencyId(e.value);
  }

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    const token = getCSRFToken();
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
    fetch('/api/admin/emergency/saveEmergencyType', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: props.data.id,
        emergencyId: getEmergencyId,
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
      <div className="container">
        <div className="overview_headline">
          <ErrorBoundary>
            <SaveInfoError responseText={responseText} errorText={errorText} />
          </ErrorBoundary>
          <ErrorBoundary>
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                <GridSimple>
                  <Row>
                    <Col xxl={5} xl={5} lg={5} md={5} sm={5} xs={5}>
                      {data.title}
                      <span>
                        <br />
                        {data.description}
                      </span>
                    </Col>
                    <Col xxl={5} xl={5} lg={5} md={5} sm={5} xs={5}>
                      <ErrorBoundary>
                        <Select
                          name="bereich"
                          defaultValue={setSelectedValue(
                            data.emergency_definition_id,
                            emergencydata.emergencyData
                          )}
                          options={emergencydata.emergencyData}
                          className="basic-multi-select"
                          onChange={e => onChangeAreaId(e)}
                        />
                      </ErrorBoundary>
                    </Col>
                    <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
                      <div className="form-group">
                        <div className="controls">
                          <button onClick={SubmitForm} className="btn btn-primary">
                            Submit
                          </button>
                        </div>
                      </div>
                    </Col>
                  </Row>
                </GridSimple>
              </Col>
            </Row>
          </ErrorBoundary>
          <ErrorBoundary>
            <SaveInfoError responseText={responseText} errorText={errorText} />
          </ErrorBoundary>
        </div>
      </div>
    </ErrorBoundary>
  );
};
export default ModulEmergencyScenario;
