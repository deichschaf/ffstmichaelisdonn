import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Select from 'react-select';
import Input from '../../component/atoms/Form/Input/Input';
import PageHeadline from '../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../component/component_helper';
import GridSimple from '../../component/molecules/GridSimple';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../component/molecules/SaveInfoError';
import SaveLine from '../../component/molecules/SaveLine';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { ToDoAreaProps } from '../../props/props';

const ToDoAreaAddEditComponent: React.FC<ToDoAreaProps> = (props: ToDoAreaProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [selectValues, setSelectValues] = useState<any>(null);
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getId, setId] = useState<number>(0);
  const [getArea, setArea] = useState<string>('');
  const [getParentId, setParentId] = useState<number>(0);
  const [getParentAreas, setParentAreas] = useState<any>([]);

  const { id } = useParams();

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function onChangeAreaId(e) {
    setParentId(e.value);
  }

  function setSelectedValue(id, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function setDefaultData(data) {
    setId(data.id);
    setArea(data.area);
    setParentId(data.parent_id);
  }

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
    fetch('/api/admin/todo/area/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: getId,
        area: getArea,
        parent_id: getParentId,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/todo/area/data/${id}`);
      response = await response.json();
      setLoading(false);
      setDefaultData(response);
    }

    async function getSelects() {
      let response = await fetch('/api/admin/todo/area/getParentAreas');
      response = await response.json();
      setParentAreas(response);
    }

    getSelects();

    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading) {
    return <LoadingAlertBox />;
  }
  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - ToDo Area ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Bereich:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getArea}
                        name="title"
                        placeholder=""
                        className="form-control"
                        onChange={e => setArea(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Unterbereich:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        defaultValue={setSelectedValue(getParentId, getParentAreas)}
                        options={getParentAreas}
                        className="basic-multi-select"
                        onChange={e => onChangeAreaId(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/admin/todo/area/overview" />
        </ErrorBoundary>
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
      </div>
    </div>
  );
};
export default ToDoAreaAddEditComponent;
